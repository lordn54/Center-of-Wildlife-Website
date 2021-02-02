<?php
function showFooter($file){
  showFooter2("", $file);   
}

function showFooter2($level, $file){

  //Do logging.  Since every page should have a footer, every page should
  //do some logging
    $remote_host=$_SERVER[REMOTE_HOST];
    $remote_addr=$_SERVER[REMOTE_ADDR];
    $user_agent=$_SERVER[HTTP_USER_AGENT];
    $page=$_SERVER[SCRIPT_FILENAME];
    recordActivity($remote_host, $remote_addr, $user_agent, $page);
?>
</div> <!-- END affiliate content -->
</div> <!-- END nonFooter -->

<!-- ____________________________ BEGIN footer ____________________________ -->

<div id="footer">
<ul id="bottomLinks">
<?php
    echo "<li><a href=\"${level}Feedback.html\">Feedback</a> </li>";
    echo "<li class=\"last\"><a href=\"${level}Contact.html\">Contact Us</a></li>";
?>
</ul>

<p class="copyright">@Copyright 2018 Embry-Riddle Aeronautical University.  All rights reserved.</p>
<p class="address">Administrative Offices: Prescott, AZ Residential Campus -
3700 Willow Creek Road,Prescott, AZ 86301-3720</p>
</div>  <!-- END footer -->

</body>
</html>

<?php
}
?>
