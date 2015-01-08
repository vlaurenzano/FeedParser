# FeedParser
Reads an xml feed and splits it into individual feed based on a tag. 

No assumptions are made about the size of the files, they are streamed though. Extends the native \XMLReader and \XMLWriter.

It's using the default spl_autoloader, so it probably won't work on linux at the moment (the linux implementation requires class file names and possibly folders to be lowercase) unless you implement your own autoloader or switch to requires. 

