
</div> 
</div>
<div id="footer"><?=date('Y')?>&nbsp;Δράση 3</div>
<?if(is_object($thisuser) && $thisuser->isStaff()) {?>
<div>
    <!-- Do not remove <img src="autocron.php" alt="" width="1" height="1" border="0" /> or your auto cron will cease to function -->
    <img src="autocron.php" alt="" width="1" height="1" border="0" />
    <!-- Do not remove <img src="autocron.php" alt="" width="1" height="1" border="0" /> or your auto cron will cease to function -->
</div>
<?}?>
</div>
</body> 
</html>
