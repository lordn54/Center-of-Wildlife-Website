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
$numberDelimiters=0;
$fullLine="";
while(<>){
    #print "here in while\n";
    my $last_word="";
    $line=$_;
    #print "line=$line\n";
    while($line){
	#print "line=$line****\n";

        if($line =~/^{/){  #delimiter at beginning of line
	    ($word)=$line=~/^{(.+)$/;
            print "delimiter at beginning of line word=$word \n";
            $line=$word;
	    $word=""; #this will be tacked on to end with else
            $numberDelimiters++;
	}
        elsif($line=~/([^{])+{/){  #delimiter not at beginning of line
            ($word, $rest)=$line=~/^([^{]+){(.*)$/;
	    print "delimiter not at beginning of word=$word\n";
            $line=$rest;
            $word="$word\{";
            $numberDelimiters++;
	}
        else {  #no delimiter, tack onto previous line
	    ($word)=$line=~/^(.*)$/;
             print "word3=$line\n";
             #$word=$line;
              $line="";
        }
        if($fullLine){
	  $fullLine=appendToLine($fullLine, $word); 
	}
        else{
	    $fullLine=$word;
	}
    }

    #print("numberDelimiters=$numberDelimiters fullLine=$fullLine!!!\n");

    if($numberDelimiters ==81){  #81
        $lines_to_output[$num_lines]=$fullLine;
        $num_lines++;
        $fullLine="";
        $numberDelimiters=0;
    }
}

#print out all the lines
#print("*************************output***************\n");
my $i;
for($i=0; $i <= $#lines_to_output; $i++){
    print "$lines_to_output[$i]\n";
}


sub appendToLine($$){
  my $line=$_[0];
  my $next_line=$_[1]; 

  ($rest, $last_word)=$next_line=~/^(.*)\s+([\w+]+)$/;

  #if the last character of $line is a ., then you don't need to
  #add one.
  if($line=~/(.*\.)\s*$/){
    $line="${1}$next_line";
  }
  else{
    $line="${line}$next_line";
  }
  return $line;
}
