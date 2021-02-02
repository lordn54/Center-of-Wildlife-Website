#include <iostream>
#include <string.h>
#include <fstream>
#include <unistd.h>

using namespace std;

int numOfColumns = 82; //82 columns in Merge Strike Reports 98 in HelpUSDA?;
int delimitersPerReport = numOfColumns-1;
char fileName[] = "strike_reports1_350000.txt"; //"strikes1990_bash.txt";
char outputFileName[] = "outputMatthewProgram.txt"; // strikes1990_bash.txt";

int DEBUG = 0;

int main(int argc, char* argv[])
{
	remove(outputFileName);
	ifstream inputFile(fileName);
	ofstream outputFile;
	outputFile.open(outputFileName, ios::app);
	string line;
	string strToPrint;
	int loopCounter = 0;
	int numberOfDelimiters = 0;
	int lineNumber = 0;
	int reportCounter = 0;
	if (inputFile.is_open() && outputFile.is_open())
	{
		while (getline(inputFile, line)) //While youre not at the end of the file
		{
			int characterCount = 0;
			while(line[characterCount] != '\000')//Loop through the line
			{
				if (line[characterCount] == '{')//If you hit a delimiter
				{
					numberOfDelimiters++;
				}
				if (line[characterCount + 2] == '\000' && numberOfDelimiters % delimitersPerReport == 0) //If you hit the end of the line, and the end of a report	
				{
					outputFile << line[characterCount];
                                        if (DEBUG){
  					  cout << line[characterCount];
					}
					outputFile << endl;
                                        if (DEBUG) {
  					  cout << endl;
					}
					usleep(1); // This time delay is necessary so the code does not write too much to the file too fast, overloading the buffer. It only delays one microsecond.
					characterCount++;
					characterCount++;
					reportCounter++;
					//numberOfDelimiters++;
					continue;
				}
				if (line[characterCount + 2] == '\000' && numberOfDelimiters % delimitersPerReport != 0) //If you hit the end of the line, but not the end of a report
				{
					outputFile << " ";
					if (DEBUG) { cout << " "; }
					characterCount++;
					continue;
				}
				if (line[characterCount] != '\r')
				{
					outputFile << line[characterCount];
					if (DEBUG) { cout << line[characterCount]; }
				}
				characterCount++;
			}
			if(line[0] != '\000' && line[characterCount-2] != '{' && numberOfDelimiters % delimitersPerReport != 0)
			//If the line isn't empty, and a new field hasn't JUST started, and you're not at the end of the report
			{
				outputFile << " ";
				if (DEBUG) { cout << " "; }
			}
		}
	}
	outputFile << endl;
	if (DEBUG) { cout << endl; }
	inputFile.close();
	outputFile.close();
}
