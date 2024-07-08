<html>
<head>
<title>SNP Info</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="icon" href="img1.png" type="image/x-icon">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style> 
p.test {
    width: 600px; 
    word-wrap: break-word;
}
.tmhig { color: #06ac60;}
.tmlow { color: #156ea6;}
    </style>
</style>
<script src="SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryValidationTextField.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {color: #123}
-->
</style>
<!-- <link href="css/bootstrap.css" rel="stylesheet" type="text/css"> -->
<link href="css/bootstrap-3.3.6.css" rel="stylesheet" type="text/css">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
<ul class="nav nav-tabs">
  <li role="disabled"><a href="index.php"><div align="center" style="font-size: 14px; alignment-baseline:middle">SNPgen<sup>®</sup> Home</div></a></li>
  <li role="presentation" class="active"><a href="SNPinfo.php">SNP info</a></li>
  <li role="presentation"><a href="arms.php">ARMS-PCR design</a></li>
  <li role="presentation" ><a href="hrm.php">HRM Assay Design (dbSNP)</a></li>
  <li role="presentation"><a href="hrm-m.php">HRM Assay Design</a></li>
  <li role="presentation"><a href="hrm-indel.php">HRM Assay Design(Indel)</a></li>
</ul>
<br>
<table width="784" border="0" align="center" class="bg-success">
<tr>
<td height="181" colspan="6" valign="top" align="center"><img src="flyer.png" width="727" height="170"></td>
</tr>
<tr height="50px">
<form id="form1" name="form1" method="get" action="">
	<td width="89" valign="top"></td>
    <td width="114" valign="top"><strong>Enter dbSNP ID (rs#): </strong></td>
    <td  colspan="2" valign="top" align="center"><span id="sprytextfield1">
    <label>rs<?php
		if($_GET==null){
			?>
			<input name="snpid" type="text" class="style1" id="snpid" onfocus="this.value=''" value="6025"/>
            <?php
		}else{?>
			<input name="snpid" type="text" class="style1" id="snpid" onfocus="this.value=''" value="<?php echo $_GET['snpid']; ?>"/>
		<?php	}
	  ?>
    </label>
    <br>
    <span class="textfieldRequiredMsg">A Number is required.</span><span class="textfieldMinCharsMsg">Minimum No. of digits not met.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span><span class="textfieldMinValueMsg">The entered value is less than the minimum required.</span></span></td>
     <td width="154" valign="top">
      <label>
      <strong><input type="submit" value="Search" name="search" id="search" >  
</strong>
      </label>
</td></form>
<td width="88" valign="top">
<?php
//Get value from user input
if(isset($_GET["search"])){
	$snp=$_GET["snpid"];
	//ncbi db query using user input dbSNP in XML format
	$surl="https://api.ncbi.nlm.nih.gov/variation/v0/beta/refsnp/".$snp;
	$json_string = file_get_contents($surl);
	if(json_decode($json_string, TRUE)==true) {
    $json_array=json_decode($json_string, TRUE);
	$snpid = $json_array["refsnp_id"];}else {
		echo "SNP ID Not Found";
	}
	?>
</td>
</tr>
<tr height="30px">
  <td valign="middle" ></td>
  <td valign="middle" bgcolor="#FAFAA9"><strong>SNP ID :</strong></td>
  <td width="124" valign="middle" bgcolor="#FAFAA9"><?php
  	echo "rs".$snp;
	//Loading variables Chrmosome and position with gene
	$allele1 = $json_array["primary_snapshot_data"]["allele_annotations"]["1"]["frequency"]["0"]["observation"]["deleted_sequence"];
	$allele2 = $json_array["primary_snapshot_data"]["allele_annotations"]["1"]["frequency"]["0"]["observation"]["inserted_sequence"];
	if($allele1=$allele2){
		$allele2 = $json_array["primary_snapshot_data"]["allele_annotations"]["0"]["frequency"]["0"]["observation"]["inserted_sequence"];
	}
	$gene = $json_array["primary_snapshot_data"]["allele_annotations"]["0"]["assembly_annotation"]["0"]["genes"]["0"]["locus"];
	$position = $json_array["primary_snapshot_data"]["anchor"];
	$elem=explode(":",$position);
	$pos = $elem[1]+1;
	$accno = $elem[0];
	$type = strtoupper($elem[3]);
	$uppos = $elem[1]-499;
	$dopos = $elem[1]+500;
	$ch = preg_replace('/[^0-9]/i', '',$elem[0]);
	$ch = (int)substr($ch, 0, -2);
	//replace 23 with X and 24 with Y chromosome
	if ($ch == 23){ $ch=="X";} 
		else {	if ($ch == 24){ $ch=="Y";}
				else{}
	}
	
	//Genebank sequence retrival 
	$giurl = file_get_contents("https://www.ncbi.nlm.nih.gov/nuccore/".$accno."?report=fasta_xml&log$=seqview&format=text&from=".$uppos."&to=".$dopos);
	$giele = explode(":",$giurl);
	$gino = preg_replace("/[^0-9]/", "", $giele[2]);
	
	$xurl= "https://www.ncbi.nlm.nih.gov/sviewer/viewer.cgi?tool=portal&save=file&log$=seqview&db=nuccore&report=fasta_xml&id=$gino&from=$uppos&to=$dopos&";
	copy($xurl,"sequence.xml");
	$url="sequence.xml";
	$seq = null;
	if(simplexml_load_file($url,"SimpleXMLElement", LIBXML_NOCDATA) ==  true) {
	$xml=simplexml_load_file($url,null, LIBXML_NOCDATA) ;
	$seq=$xml->TSeq->TSeq_sequence;
	?></td>
  <td width="169" align="right" valign="middle" bgcolor="#FAFAA9"><strong>Gene :</strong></td>
  <td align="left" valign="middle" bgcolor="#FAFAA9"><?php echo $gene; ?></td>
  <td valign="middle"></td>
 
</tr>
<tr height="30px">
  <td valign="middle" align="center"></td>
  <td align="left" valign="middle" bgcolor="#FAFAA9"><strong>Chromosome : </strong></td>
  <td align="left" valign="middle" bgcolor="#FAFAA9"><?php //replace 23 with X and 24 with Y chromosome
	if ($ch == 23){ echo "X";} 
		else {	if ($ch == 24){ echo "Y";}
				else{echo $ch;}
	} ?></td>
  <td align="right" valign="middle" bgcolor="#FAFAA9"><strong>Position : </strong></td>
  <td valign="middle" bgcolor="#FAFAA9"><?php echo $pos; ?></td>
  <td valign="middle"></td>
</tr>
<tr height="30px">
  <td valign="middle"></td>
  <td colspan="3" valign="middle" bgcolor="#FAFAA9" ><strong>Type : </strong><?php echo $type; ?> </td>
  <td colspan="1" valign="middle" bgcolor="#FAFAA9"></td>
  <td valign="top" colspan="1"></td>
</tr>
<tr height="30px">
  <td valign="bottom"></td>
  <td valign="bottom" bgcolor="#FAFAA9"><strong>Sequence :</strong></td>
  <td align="center" valign="middle" bgcolor="#FAFAA9">&nbsp;</td>
  <td valign="middle" bgcolor="#FAFAA9"><strong></strong></td>
  <td valign="middle" bgcolor="#FAFAA9"><strong><?php 
  $ncbi="https://www.ncbi.nlm.nih.gov/SNP/snp_ref.cgi?type=rs&rs=".$snpid;
  echo "<a href='$ncbi'>dbSNP Webpage</a>" ?></strong></td>
  <td valign="middle"></td>
</tr>
<tr>
  <td valign="middle"></td>
  <td valign="middle" colspan="4">
    <table width="730" height="100" border="1"><tr>
      <td bgcolor="#FFFFFF" align="left" height="25"><?php 
	// Loading sequences limiting the upstream to 500bp and downstream to 499
	echo chunk_split(substr($seq,0,500), 10, ' ')." <strong>[<span class='tmlow'>".$allele1."</span>/<span class='tmhig'>".$allele2."</span>]</strong> ".chunk_split(substr($seq,501), 10, ' ');
	}}
?>
  </td></tr></table></td>
  <td valign="middle"></td>
</tr>
    </form>
</table>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {minChars:2, validateOn:["blur", "change"], minValue:2});
//-->
</script>
<footer><br>
  <p align="center">Designed by : <a href="mailto:kajan.muneeswaran@gmail.com">M. Kajan </a> for <a href="https://www.facebook.com/BioTech.edu.lk/">Biotechnology Forum Sri Lanka</a> </p>
</footer>
</body>
</html>

