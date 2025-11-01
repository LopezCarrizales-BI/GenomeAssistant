const SNP_PATRON = /^rs\d+$/;
const GEN_COORDINATES_PATRON = /^\d{1,2}:\d{6,}-\d{6,}$/;
const GEN_PATRON = /^[A-Z0-9]+$/;
const HGVS_PATRON = /^[A-Z]{2}_\d+\.\d+:[cgmnpr]\..+$/;

export function classifyInput(input) {
  console.log(input);
  console.log(SNP_PATRON.test(input));
  if (SNP_PATRON.test(input)) return "snp";
  if (GEN_COORDINATES_PATRON.test(input)) return "coordinates";
  if (GEN_PATRON.test(input)) return "gen";
  if (HGVS_PATRON.test(input)) return "hgvs";

  return "unknown";
}
