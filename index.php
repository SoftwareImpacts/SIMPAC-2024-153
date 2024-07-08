<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SNPgen® Server</title>
<link rel="icon" href="img1.png" type="image/x-icon">
<!-- <link href="css/bootstrap.css" rel="stylesheet" type="text/css"> -->
<link href="css/bootstrap-3.3.6.css" rel="stylesheet" type="text/css">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<style>
a.button { 
    background-color: #80B763;
    border-radius: 5px;
    color: #FFFFFF;
    display: inline-block;
    font-weight: bold;
    padding: 8px 22px;
    font-size: 0.8em;
    letter-spacing: 0.25px;
    text-decoration: none;
}

a.button-reversed { 
    background-color: #333;
}

a.button:hover {
	background-color: #669D48;
}

a.button-reversed:hover {
	background-color: #222;
}
</style>
</head>

<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.12&appId=2019081855022826&autoLogAppEvents=1';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<ul class="nav nav-tabs">
  <li role="disabled" class="active"><a href="index.php">
  <div align="center" style="font-size: 14px; alignment-baseline:middle">SNPgen<sup>®</sup> Home</div></a></li>
  <li role="presentation" ><a href="SNPinfo.php">SNP info</a></li>
  <li role="presentation"><a href="arms.php">ARMS-PCR design</a></li>
  <li role="presentation" ><a href="hrm.php">HRM Assay Design (dbSNP)</a></li>
  <li role="presentation"><a href="hrm-m.php">HRM Assay Design</a></li>
  <li role="presentation"><a href="hrm-indel.php">HRM Assay Design(Indel)</a></li>
</ul>
<table align="center" width="96%" cellpadding="0" cellspacing="0" border="0">
<tr>
<td colspan="4" width="69%"><table width="96%" align="center"><tr><td>
<div align="left">
<h2>Introduction to SNPgen<sup>&reg;</sup></h2>
<p align="justify">Welcome to SNPgen<sup>&reg;</sup> SNP Genotyping assay designer portal. This site provides set of free tools to design Amplification Refractory Mutation System (ARMS) PCR and High Resolution Melt (HRM) based Single Nucleotide Polymorphism (SNP) Genotyping assays for the Molecular Biologists around the world. </p>
<p align="justify">These tools were more convenient and easier to use to design a SNP genotyping assay for both end-point PCR and qPCR platforms. Tool only requires the dbSNP ID from the user to provide the all relevant information via the NCBI E-utils and allow user to design an primers with just 2 clicks.</p>
</div><br></td></tr></table>
</td>
</tr>
<tr>
<td width="23%" align="center" valign="top"><table width="90%" align="center"><tr><td>
<h3>SNP info </h3>
<p align="justify">This tool provides the Basic information about your SNP of interest from the dbSNP database ID (rs#) provided. Also this gives the Gene and Protein representation of the mutation if it's a missence mutation.</p></td></tr><tr><td>
<p align="center">
<a href="SNPinfo.php" class="button"><img src="img1.png" height="20" width="20"> SNP info</a>
</p>
</td></tr></table>
</td>
<td width="23%" valign="top">
<table width="90%" align="center"><tr><td>
<h3>ARMS-PCR Design Tool</h3>
<p align="justify">This tool allow the user to design the ARMS-PCR primer in no time using the dbSNP ID / rs#. Tool provides best two(2) sets of ARMS-PCR primer for the user. Tool provided the alleles and default PCR conditions for user convenience</p></td></tr><tr><td>
<p align="center">
<a href="arms.php" class="button"><img src="img2.png" height="20" width="20"> ARMS-PCR Design (dbSNP)</a><br><br>
<a href="http://primer1.soton.ac.uk/primer1.html" class="button"><img src="img2.png" height="20" width="20"> ARMS-PCR Design</a>
</p><br>
</td></tr></table>
</td>
<td width="23%" valign="top">
<table width="90%" align="center"><tr><td>
<h3>HRM Assay Design Tool</h3>
<p align="justify">SNP genotyping assay on low-end qPCR instrumentation was made possible using this tool by increasing the melting temperature difference between different allele spcific products using the CADMA methodology</p></td></tr><tr><td>
<p align="center">
<a href="hrm.php" class="button"><img src="img3.png" height="20" width="20"> HRM Assay Design (dbSNP)</a><br><br>
<a href="hrm-m.php" class="button"><img src="img3.png" height="20" width="20"> HRM Assay Design</a><br><br>
<a href="hrm-indel.php" class="button"><img src="img3.png" height="20" width="20"> HRM Assay Design - Indel</a>
</p>
</td></tr></table>
</td>
<td width="23%" align="right" rowspan="2">
<div class="fb-page" data-href="https://www.facebook.com/BioTech.edu.lk/" data-tabs="timeline" data-width="380" data-height="500" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" align="right"><blockquote cite="https://www.facebook.com/BioTech.edu.lk/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/BioTech.edu.lk/">Biotechnology Forum - Sri Lanka</a></blockquote></div>
</td>
</tr>
<tr>
<td width="23%" align="center" valign="top"><table width="90%" align="center"><tr><td>
<p align="justify"> Single nucleotide polymorphisms, frequently called <strong>SNPs</strong> (pronounced “snips”), are the most common type of genetic variation among people. Each SNP represents a difference in a single DNA building block, called a nucleotide. For example, a SNP may replace the nucleotide cytosine (C) with the nucleotide thymine (T) in a certain stretch of DNA. SNPs have proven to be very important in the study of human health.</p></td></tr><tr><td>
<p align="right"><a href="https://en.wikipedia.org/wiki/Single-nucleotide_polymorphism" class="button2">Read More..</a>
</p>
</td></tr></table>
</td>
<td width="23%" align="center" valign="top"><table width="90%" align="center"><tr><td>
<p align="justify"> Tetra-primer amplification refractory mutation system PCR, or <strong>ARMS-PCR</strong>, employs two pairs of primers to amplify two alleles in one PCR reaction. The primers are designed such that the two primer pairs overlap at a SNP location but each match perfectly to only one of the possible SNPs. The basis of the invention is that unexpectedly, oligonucleotides with a mismatched 3'-residue will not function as primers in the PCR. </p></td></tr><tr><td>
<p align="right"><a href="https://books.google.lk/books?id=TZVnFFFL8rAC&pg=PA18&dq=ARMS-PCR&hl=en&sa=X&ved=0ahUKEwi159ShgaTaAhXEEpQKHe1vCvgQ6AEIJzAA#v=onepage&q=ARMS-PCR&f=false" class="button2">Read More..</a>
</p>
</td></tr></table>
</td>
<td width="23%" align="center" valign="top"><table width="90%" align="center"><tr><td>
<p align="justify"> High Resolution Melt (HRM) analysis is a powerful technique in molecular biology for the detection of mutations, polymorphisms and epigenetic differences in double-stranded DNA samples. It was discovered and developed by Idaho Technology and the University of Utah. It is closed tube, simple, fast, cost effective (vs. other genotyping technologies) and powerful technology to genotype mutations accurately.</p></td></tr><tr><td>
<p align="right"><a href="https://en.wikipedia.org/wiki/High_Resolution_Melt" class="button2">Read More..</a>
</p>
</td></tr></table>
</td>
<td></td>
</tr>
<tr>
<td colspan="4"><table width="90%" align="center"><tr><td>
<h4 align="center">COPYRIGHTS<sup>©</sup></h4>
<p>SNPgen<sup>&reg;</sup> is a registered trademark of <a href="https://www.facebook.com/BioTech.edu.lk/">Biotechnology Forum Sri Lanka</a>, unauthorized use of its name, trademark and other intelletual properties are highly prohibited</p>
<p align="center"> Designed By: <a href="mailto:kajan.muneeswaran@gmail.com">Kajan Muneeswaran</a> </p>
</td></tr></table></td>
</tr>
</table>


</body>
</html>