<?php @error_reporting(0); @ini_set("display_errors", 0);  

if (version_compare(VERSION . '.' . BUILD, '2.8.9', '>'))
{
	try { $objDatabase = Database::getInstance(); } catch (Exception $e) { $errors[] = $e->getMessage(); }		
	try { $objDatabase->listTables(); } catch (Exception $e) { $errors[] = $e->getMessage(); }
	
	$migration = false;
	$addTemplate = false;
	
	if ($objDatabase->tableExists('tl_visitors_category')) 
	{
		if ($objDatabase->fieldExists('visitors_template', 'tl_visitors_category') 
		&& !$objDatabase->fieldExists('visitors_template', 'tl_module'))
		{
			//Migration mit Neufeldanlegung
			//Feld anlegen
			try { $objDatabase->execute("ALTER TABLE `tl_module` ADD `visitors_template` varchar(32) NOT NULL default ''"); } catch (Exception $e) { $errors[] = $e->getMessage(); }
			$addTemplate = true;
			//Feld versuchen zu fuellen, macht der naechste Abschnitt
		}
		
		if ( ($objDatabase->fieldExists('visitors_template', 'tl_visitors_category') 
		   && $objDatabase->fieldExists('visitors_template', 'tl_module')) || $addTemplate === true)
		{
			//Test ob Feld in allen Visitors Modulen leer
			try { $objTemplates = $objDatabase->execute("SELECT count(visitors_template) AS ANZ FROM tl_module WHERE visitors_template !=''"); } catch (Exception $e) { $errors[] = $e->getMessage(); }
			while ($objTemplates->next())
			{
				if ($objTemplates->ANZ > 0) {
					//nicht gefuellt
					$migration = false;
				} else {
					$migration = true;
				}
			}
			
			if ($migration == true) {
				//Feld versuchen zu fuellen
				try { $objVisitorsTemplatesNew = $objDatabase->execute("SELECT `id`, `name` , `visitors_categories` FROM `tl_module` WHERE `type`='visitors'"); } catch (Exception $e) { $errors[] = $e->getMessage(); }
				while ($objVisitorsTemplatesNew->next())
				{
					if (strpos($objVisitorsTemplatesNew->visitors_categories,':') !== false) 
					{
						$arrKat = deserialize($objVisitorsTemplatesNew->visitors_categories, true);
					} else {
						$arrKat = array($objVisitorsTemplatesNew->visitors_categories);
					}
					if (count($arrKat) == 1 && (int)$arrKat[0] >0) 
					{ //nicht NULL
						//eine eindeutige Zuordnung, kann eindeutig migriert werden
						try { $objTemplatesOld = $objDatabase->execute("SELECT `id`, `title`, `visitors_template` FROM `tl_visitors_category` WHERE id =".$arrKat[0].""); } catch (Exception $e) { $errors[] = $e->getMessage(); }
						while ($objTemplatesOld->next())
						{
							try { $objDatabase->prepare("UPDATE tl_module SET visitors_template=? WHERE id=?")->execute($objTemplatesOld->visitors_template, $objVisitorsTemplatesNew->id); } catch (Exception $e) { $errors[] = $e->getMessage(); }
							//Protokoll
							$strText = 'Visitors-Module "'.$objVisitorsTemplatesNew->name.'" has been migrated';
							try { $objDatabase->prepare("INSERT INTO tl_log (tstamp, source, action, username, text, func, ip, browser) VALUES(?, ?, ?, ?, ?, ?, ?, ?)")->execute(time(), 'BE', 'CONFIGURATION', '', specialchars($strText), 'Visitors Modul Template Migration', '127.0.0.1', 'NoBrowser'); } catch (Exception $e) { $errors[] = $e->getMessage(); }
						}
					} elseif (count($arrKat) > 1) {
						try { $objTemplatesOld = $objDatabase->execute("SELECT `id`, `title`, `visitors_template` FROM `tl_visitors_category` WHERE id =".$arrKat[0].""); } catch (Exception $e) { $errors[] = $e->getMessage(); }
						while ($objTemplatesOld->next())
						{
							//Protokoll
							$strText = 'Visitors-Module "'.$objVisitorsTemplatesNew->name.'" could not be migrated';
							try { $objDatabase->prepare("INSERT INTO tl_log (tstamp, source, action, username, text, func, ip, browser) VALUES(?, ?, ?, ?, ?, ?, ?, ?)")->execute(time(), 'BE', 'ERROR', '', specialchars($strText), 'Visitors Modul Template Migration', '127.0.0.1', 'NoBrowser'); } catch (Exception $e) { $errors[] = $e->getMessage(); }
						}
					}
				}
				try { $objDatabase->execute("UPDATE `tl_visitors_browser` SET `visitors_counter`=0 WHERE `visitors_browser`='Unknown' AND `visitors_os`='Unknown'"); } catch (Exception $e) { $errors[] = $e->getMessage(); }
			}
		}
		if ($objDatabase->tableExists('tl_visitors_searchengines')) 
		{
			//Korrektur 2.1 nach 2.2
			try { $objDatabase->execute("DELETE FROM `tl_visitors_searchengines` WHERE `visitors_searchengine` = 'Yandex' AND `visitors_keywords`=''"); } catch (Exception $e) { $errors[] = $e->getMessage(); }
			try { $objDatabase->execute("UPDATE `tl_visitors_browser` SET `visitors_counter`=0 WHERE `visitors_browser`='Unknown' AND `visitors_os`='Unknown'"); } catch (Exception $e) { $errors[] = $e->getMessage(); }
		}
	}
} else {
	$objDatabase = Database::getInstance();
	try { $objDatabase->prepare("INSERT INTO tl_log (tstamp, source, action, username, text, func, ip, browser) VALUES(?, ?, ?, ?, ?, ?, ?, ?)")->execute(time(), 'FE', 'ERROR', ($GLOBALS['TL_USERNAME'] ? $GLOBALS['TL_USERNAME'] : ''), 'ERROR: Visitors-Module requires at least Contao 2.9', 'ModulVisitors Runonce', '127.0.0.1', 'NoBrowser'); } catch (Exception $e) { $errors[] = $e->getMessage(); }
}

?>