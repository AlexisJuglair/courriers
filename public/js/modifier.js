window.onload = () =>
{
    console.log("check_modif()");
    let check_modif = document.querySelectorAll(".check-courrier");
    let counter = 0;

    for (let cm of check_modif) 
    {
        cm.addEventListener("change", function()
        {
            if (cm.checked) 
            {   
                counter++;
                console.log("++"+counter);
            }
            else
            {
                counter--;
                console.log("--"+counter);
            }

            if (counter == 1)
            {
                console.log("test 3");
                document.getElementById("modif-courrier").setAttribute("formaction", "/courrier/"+cm.value+"/edit");
            }
            else
            {
                console.log("test4");
                document.getElementById("modif-courrier").setAttribute("formaction", "/");
            }
        })
    }
}