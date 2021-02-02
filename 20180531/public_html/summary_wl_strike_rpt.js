//  This Javascript function will forward the user to the wildlife  
//  summary report for an individual airport or the 
//  stats Summary report for the chosen FAARegion or State
//
function checkStrikeRptSelection() {
        airport_id = document.Query.Airport_id.value
        /*alert("here airport_id="+airport_id)*/
        state = document.Query.State2.value
        /*alert("here state="+state); */
        region = document.Query.FAARegion2.value
        /*alert("here region="+region);*/ 

        /*NOTE: these paths may need to be adjusted when restriced/index.php is 
edited */
        if(airport_id != "Select") {
                document.location = "strike_index/" + airport_id + ".html";
        }
        /*alert("state.selectedIndex="+document.Query.State2.selectedIndex);*/
        else if(state != "Select") {
                document.location = "statsSummaryResults.php?state="+state;
         }
        /*alert("state.selectedIndex="+document.Query.FAARegion2.selectedIndex);*/

        else if(region != "Select") {
                document.location = "statsSummaryResults.php?faaregion="+region;
        }

}
