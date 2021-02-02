#!/usr/local/bin/perl
# Program:      findTabs.pl
#
# Description:  4/29/2014 there was a problem processing imports1.txt 
#               my hypothesis is that it contains tabs (which are supposed to
#               be the delimiter character.)
#               So I instead am exporting from Access with { as delimiter
#               and then running this to replace tabes with a single space
#               and then replace { with tab 
#               (mySQL wants tab delimiters by default) 
#
#
# Run as: findTabs.pl < imports.txt >importsFixed.txt 
#         imports.txt      -   Is a dump of the Access reports table.  
############################################################################
my @lines_to_output;
my $num_lines=0;

#print "in remove Paragraph\n";

while(<>){
    #print "here in while\n";
    my $last_word="";
    $line=$_;
    if($line =~ /\t/){
      #print "This line has a tab:$line\n";
    } 
    $line=~ s/\t/ /g;
    $line=~ s/{/\t/g;

    print "$line";
}

