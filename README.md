# IPv4 VPN Blocklist for WordFence

## Import

Simply import output.sql in your WordPress database. (WordFence should already be installed!)
It will block all known VPN providers.

## Sources

The list (ipv4.txt) is from here: https://github.com/X4BNet/lists_vpn

## Regenerating output.sql

The generate.php script will create output.sql. Simply place the updated version of ipv4.txt in this repo and execute `php generate.php` (PHP CLI 8.0)
