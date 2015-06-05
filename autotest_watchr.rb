# gem install watchr
# Command to run this: watchr /path/to/file/autotest_watchr.rb
 
 
#####
system %(echo "Running autotest_watchr.rb")

#####
# Watch the classes folder for changes
# If there's a change to a class, look for it's corresponding Test file.
# Ex if Shopper.php changes, it'd run the test on ShopperTest.php in tests folder
watch("classes/(.*).php") do |match|
  run_test %{tests/#{match[1]}Test.php}
end

#####
# Also watch for changes to the test files
watch("tests/.*Test.php") do |match|
  run_test match[0]
end

def run_test(file)

  clear_console

  # First, make sure the file exists
  unless File.exist?(file)
    puts "#{file} does not exist"
    return
  end
 
  # Now run the PHPUnit test on the file
  puts "Running #{file}"
  result = `phpunit #{file}`
  puts result
  
  if result.match(/OK/)
    notify "#{file}", "Tests Passed Successfuly", "dialog-information.png", 4000
  elsif result.match(/FAILURES\!/)
    notify_failed "#{file}", "#{result}"
  end
end

###
def notify_failed cmd, result
  failed_examples = result.scan(/failures:\n\n(.*)\n/)
  notify "#{cmd}", failed_examples[0], "dialog-error.png", 6000
end

###
def notify title, msg, img, show_time
  images_dir='/usr/share/icons/Mint-X/status/48'
  system "notify-send '#{title}' '#{msg}' -i #{images_dir}/#{img} -t #{show_time}"
end

#####
def clear_console
  puts "\e[H\e[2J" 
end
