<?php
header("Content-type: text/xml; charset=utf-8");
$emailaddress = $_GET["emailaddress"];
$emailaddress = explode("@", $emailaddress)[0];
$emailaddress_parts = explode(".", $emailaddress);
$new_address = $emailaddress_parts[0][0] . $emailaddress_parts[1];
?>
<?xml version="1.0" encoding="UTF-8"?>
<clientConfig version="1.1">
  <emailProvider id="stuvus.uni-stuttgart.de">
    <domain>stuvus.uni-stuttgart.de</domain>
    <displayName>Studierendenvertretung Universität Stuttgart</displayName>
    <displayShortName>stuvus</displayShortName>
    <incomingServer type="imap">
      <hostname>imap.stuvus.uni-stuttgart.de</hostname>
      <port>143</port>
      <socketType>STARTTLS</socketType>
      <authentication>password-cleartext</authentication>
      <username><?php echo $new_address; ?></username>
    </incomingServer>
    <outgoingServer type="smtp">
      <hostname>smtp.stuvus.uni-stuttgart.de</hostname>
      <port>587</port>
      <socketType>STARTTLS</socketType>
      <authentication>password-cleartext</authentication>
      <username><?php echo $new_address; ?></username>
    </outgoingServer>
    <documentation url="https://wiki.stuvus.uni-stuttgart.de/display/ITKB/Mail">
      <descr lang="de">Allgemeine Beschreibung der Einstellungen</descr>
      <descr lang="en">Generic settings page</descr>
    </documentation>
  </emailProvider>
</clientConfig>
