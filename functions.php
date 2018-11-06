<?php
<script>
function dropdownfuntion(){
    document.getElementById("dropdownlist").classList.toggle("show");
}

window.onclick = function(event){
    if (!event.target.matches('.button')){
        var dropdown = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdown.length; i++){
            var openDropDown = DropDowns[i];
            if (OpenDropdown.classList.contains('show')){
                openDrowdown.classlist.remove('show');
            }
        }
    }
}
</script>
