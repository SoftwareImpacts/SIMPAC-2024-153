SNPgen: A Web Portal for Simplified SNP and Indel Genotyping Primer Design

SNPgen is a web-based portal that simplifies primer design for single nucleotide polymorphisms (SNPs) and insertions/deletions (indels). It offers a user-friendly suite of tools that automates primer design, making genotyping workflows more efficient and reliable.

Key Features

    SNP info tool: Retrieves essential details about SNPs, including chromosome, position, gene, variant type, and flanking sequences, from the dbSNP database.
    ARMS-PCR primer design tool: Designs tetra-primer ARMS-PCR primers for SNP genotyping based on user-provided dbSNP IDs.
    HRM assay design tools:
        (dbSNP): Designs qPCR assays based on the mCADMA method for SNP genotyping using user-provided dbSNP IDs.
        (Sequence): Designs HRM assays based on mCADMA for user-provided sequences (independent of dbSNP).
        (Indel): Designs HRM assays based on mCADMA for indel genotyping using user-provided sequences.
    Considers factors like GC content and melting temperature (Tm) for optimal primer design.
    Provides expected Tm values for different genotypes in HRM assays.
    Visually represents amplicons and primers for HRM assays.

Benefits

    Saves time and effort compared to manual primer design.
    Increases accuracy and reliability of genotyping assays.
    User-friendly interface for researchers with varying levels of bioinformatics expertise.
    Applicable to diverse fields, including medical genetics, pharmacogenomics, agriculture, and livestock biotechnology.

How to Use SNPgen

    Visit the SNPgen website (snp.biotech.edu.lk).
    Select the desired tool based on your needs (e.g., SNP info, ARMS-PCR design, HRM assay design).
    Follow the tool's instructions and provide the necessary input (e.g., dbSNP ID, sequence).
    Click the "Run" or "Design" button to generate the primers and results.
    Analyze the results, including primer sequences, amplicon sizes, and expected Tm values.

Installation Instructions

SNPgen is a web-based application designed to run on a PHP server. Here's a guide to install SNPgen on your server:

Prerequisites:

    PHP server (version 5.6 or above) with:
        mod_rewrite enabled (for URL rewriting)
    Web server (e.g., Apache, Nginx)

Download and Extraction

    Visit https://snp.biotech.edu.lk/A-SNPgen.zip.
    Download the SNPgen installation package (A-SNPgen.zip).
    Extract the contents of the downloaded ZIP file onto your web server's document root directory. This is typically the public_html, htdocs, or www directory, depending on your server configuration.

Permissions

    Grant read and execute permissions (usually 755) to the following directories within the extracted SNPgen folder:
        css
        images (if applicable)
        js
    Grant write permissions (usually 777) to the following directories within the extracted SNPgen folder:
        tmp (for temporary file storage)

Configuration (Optional)

    If you plan to use a database for user data or preferences, create a database and configure the database connection details in the config.php file located within the extracted SNPgen directory. Refer to the comments within the file for specific instructions.

Web Server Configuration (Optional, for URL rewriting)

If your web server doesn't handle URL rewriting by default (e.g., Apache with mod_rewrite enabled), you might need to create a rewrite rule in your web server's configuration file (e.g., .htaccess for Apache) to redirect requests to the SNPgen index file (usually index.php). The specific rewrite rule will depend on your web server setup. Consult your web server's documentation for details on creating rewrite rules.

Verification

    Open a web browser and navigate to the URL where you uploaded the extracted SNPgen files (e.g., [invalid URL removed]).
    You should see the SNPgen web interface if the installation was successful.

Additional Notes

    If you encounter any issues during installation, seek assistance from the SNPgen developers whose details could be found on the footer of every webpage.
    Consider security best practices when setting permissions on directories and files. The recommended permissions in this guide are a starting point, and you might need to adjust them based

License
    SNPgen is licensed under the Apache License, Version
