<?php $host = $_SERVER['SERVER_NAME']; // check which machine we're on... ?>

<?php if (strpos($host, 'library.ucsc') === false): ?>
  <iframe width="950" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
  src="https://maps.google.com/maps/ms?msa=0&amp;msid=206723407710575786600.0004c32be5bc05f7a0b81&amp;ie=UTF8&amp;t=h&amp;ll=42.55308,-48.339844&amp;spn=55.121316,166.816406&amp;z=3&amp;output=embed"></iframe>
<?php else: ?>
  <iframe width="950" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
  src="https://maps.google.com/maps/ms?msa=0&amp;msid=206723407710575786600.0004c32c00381f43c5bba&amp;ie=UTF8&amp;t=h&amp;ll=42.811522,-47.285156&amp;spn=54.926026,166.816406&amp;z=3&amp;output=embed"></iframe>
<?php endif; ?>
