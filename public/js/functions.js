function createCookie(e,r,t){let o;if(t){let e=new Date;e.setTime(e.getTime()+24*t*60*60*1e3),o="; expires="+e.toGMTString()}else o="";document.cookie=`${e}=${r}${o}; path=/`}function deleteCookie(e){createCookie(e,"",-1)}function getPrefer(e){$.ajax({url:"/prefer/get",data:JSON.stringify({endpoint:e,_token:CSRF}),dataType:"json",contentType:"application/json",type:"POST"}).done((e=>{if(e.success){let r=0;for(let t=0;t<e.pref.length;t++)e.pref[t]&&($("#p"+(t+1)).attr("checked",!0),r++);r===e.pref.length&&$("#all").attr("checked",!0),$("#preferencias").removeClass("d-none")}else void 0!==e.message?errorAlert(e.message):errorAlert("Falha")})).fail((()=>{errorAlert("Falha")}))}function errorAlert(e){$("#error-message").html(e),new bootstrap.Toast(document.getElementById("error-alert")).show()}function getPrefer(e){$.ajax({url:"/prefer/get",data:JSON.stringify({endpoint:e,_token:CSRF}),dataType:"json",contentType:"application/json",type:"POST"}).done((e=>{if(e.success){let r=0;for(let t=0;t<e.pref.length;t++)e.pref[t]&&($("#p"+(t+1)).attr("checked",!0),r++);r===e.pref.length&&$("#all").attr("checked",!0),$("#preferencias").removeClass("d-none")}else void 0!==e.message?errorAlert(e.message):errorAlert("Falha")})).fail((()=>{errorAlert("Falha")}))}function errorAlert(e){$("#error-message").html(e),new bootstrap.Toast(document.getElementById("error-alert")).show()}
