# StorjDashboard [ Internal ]
Internally run storj dashboard for multinode

Please check releases for the latest one.<br><br>
<a href="https://github.com/storjdashboard/storjdashboard-internal/releases">Releases</a>
<br>
<a href="https://docs.storjdashboard.com/internal">Docs Guide</a>

<h2> Manual Updating </h2>
<p>Replace [VERSION] with the version number - for example: 1.0.0.7<br><br>
  (1) <code>cd /var/www/html/dashboard/include_content/scripts/update/downloads/ && wget https://github.com/storjdashboard/storjdashboard-internal/archive/refs/tags/[VERSION].tar.gz</code><br><br>
  (2) <code>sudo bash /var/www/html/dashboard/include_content/scripts/update/linux_updater.sh /var/www/html/dashboard [VERSION].tar.gz [VERSION]</code><br>
</p>
