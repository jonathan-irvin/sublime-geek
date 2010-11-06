{if $errormessage}

  <div class="errorbox">
    {$errormessage}
  </div>

{else}

  <div class="successbox">
    {$LANG.pwresetvalidationsuccess}
  </div>

  <p>{$LANG.pwresetvalidationsuccessdesc}</p>

{/if}