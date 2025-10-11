use strict;
use warnings;
use LWP::Simple;
use JSON;

my $data_type = $ARGV[0];
my $value     = $ARGV[1];
die "Error: Se requieren dos argumentos: data-type y value.\n"
  unless ( $data_type && $value );

my $server = "https://rest.ensembl.org";
my $ext;

if ( $data_type eq 'snp' ) {
    $ext = "/variation/homo_sapiens/$value?content-type=application/json";
}
elsif ( $data_type eq 'name' ) {
    $ext = "/lookup/symbol/homo_sapiens/$value?content-type=application/json";
}
elsif ( $data_type eq 'genomic-coordinates' ) {
    $ext = "/overlap/region/homo_sapiens/$value?content-type=application/json";
}
else {
    die "Error: Tipo de dato '$data_type' no soportado.\n";
}

my $url = $server . $ext;

my $content = get($url);
die "Error al contactar la API: $!" unless defined $content;

print $content;

exit 0;
