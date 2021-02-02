#!/usr/local/bin/perl
# Program:      removeParagraph.pl
#
# Description:  The input for this program is a text file of the Access 
#               reports table.  An assumption is made that Yes or No will be
#               the last word for each record.  If a newline character is
#               found anywhere else in the file it is removed.  In the case
#               that a newline is removed, a period and two spaces are added
#               if the line doesn't already end in a period.
#
# Run as: removeParagraph.pl < imports.txt > new_imports.txt
#         imports.txt      -   Is a dump of the Access reports table.  
#         new_imports.txt  -   A modified version of the input file with
#                              extra newlines removed.
############################################################################
my @lines_to_output;
my $num_lines=0;

#print "in remove Paragraph\n";

while(<>){
    #print "here in while\n";
    my $last_word="";
    $line=$_;
#print "line=$line\n";
    ($index_num)=$line=~/^(\d+)\s.*/;
    ($last_word)=$line=~/^\d+\s.*\s+([\w]+)$/;

#print "index_num=$index_num last_word=$last_word\n";

    #Append this line to the previous if
    #the line does not start with a number (index_nr)
    if(($index_num eq "") && (!($line =~/^[\s\n]*$/))){
      #this line should be appended to the previous one
      $prev_line=$lines_to_output[($num_lines-1)];
      chop($prev_line);
      $new_line=appendToLine($prev_line,  $line);
      #print "num_lines=$num_lines\n";
      $lines_to_output[($num_lines-1)]=$new_line;
      #print "new_line=$new_line\n";
    }
    # Append this line to the previous if 
    # the line does not end with a Yes or No.
    else{
	while(!(($last_word eq "No") || ($last_word eq "Yes"))){
	    $next_line=<>;
            chop($line); 
	    $line=appendToLine($line, $next_line);
	    ($rest, $last_word)=$next_line=~/^(.*)\s+([\w+]+)$/;
	}
        $lines_to_output[$num_lines]=$line;
        $num_lines++;
  }

}

#print out all the lines
my $i;
for($i=0; $i <= $#lines_to_output; $i++){
    print "$lines_to_output[$i]";
}


sub appendToLine($$){
  my $line=$_[0];
  my $next_line=$_[1]; 

  ($rest, $last_word)=$next_line=~/^(.*)\s+([\w+]+)$/;

  #if the last character of $line is a ., then you don't need to
  #add one.
  if($line=~/(.*\.)\s*$/){
    $line="$1  $next_line";
  }
  else{
    $line="$line.  $next_line";
  }
  return $line;
}
