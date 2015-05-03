#!/usr/bin/perl

use CGI::Carp 'fatalsToBrowser';
use CGI qw(:standard);
use File::Basename;

my $path_base = "/home3/ritanonn/public_html/pigreco/filetor/";
my $upload_dir = $path_base . "/service";

%queryString = ();
my $tmpStr = $ENV{"QUERY_STRING"};
@parts = split( /\&/, $tmpStr);
foreach $part (@parts) {
	($name, $value) = split( /\=/, $part);
	$queryString{"$name"} = $value;
}

$sid = $queryString{"sid"};

$links = "success.php?sid=$sid";

my $len = $ENV{"CONTENT_LENGTH"};
open FILEHAN, ">/home3/ritanonn/public_html/pigreco/filetor/service/$sid.txt.len";
print FILEHAN $len;
close FILEHAN;

#open OLDHAND, ">/home3/ritanonn/public_html/pigreco/filetor/service/$sid.txt.old";
#print OLDHAND "0";
#close OLDHAND;

my $query = CGI->new(\&_hook, $sid);
my $upload_filehandle = $query->upload("file");

open UPLOADFILE, ">$upload_dir/$sid.txt";
binmode UPLOADFILE;

while(read($upload_filehandle, $data_buff, 1024)) {
	print UPLOADFILE $data_buff;
}

close UPLOADFILE;

print "Content-type:text/html\n";
print "Location:$links\n\n";

sub _hook {
	my ($filename, $buffer, $bytes_read, $umid) = @_;
	$myfile = $filename;
	$len = length($myfile);
	$i = $len;
	$trovato = 0;
	while(($trovato == 0) && ($i > 0)) {
		$i = $i - 1;
		$carattere = substr($myfile, $i, 1);
		if(($carattere == "\\") || ($carattere == "/")) {
			$trovato = 1;
		}
	}
	$veronome = substr($myfile, $i + 1, $len - $i);
	open FILEHA, ">/home3/ritanonn/public_html/pigreco/filetor/service/$umid.txt.name";
	print FILEHA basename($filename);
	close FILEHA;
	open FILEH, ">/home3/ritanonn/public_html/pigreco/filetor/service/$umid.txt.transf";
	print FILEH $bytes_read;
	close FILEH;
}
