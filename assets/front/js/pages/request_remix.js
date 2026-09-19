document.addEventListener("DOMContentLoaded", function(){
    const form = document.getElementById("customRemixForm");
    if(!form) return;

    form.addEventListener("submit", async function(e){
        e.preventDefault();

        const fd = new FormData(form);

        try{
            const res = await fetch(window.DMB.baseUrl + 'pages/submit_request_remix', {
                method: "POST",
                body: fd
            });
            const json = await res.json();

            if(json && json.success){
                alert("Request sent successfully!");
                form.reset();
            }else{
                alert((json && json.message) ? json.message : "Error sending request.");
            }
        }catch(err){
            alert("Network error.");
        }
    });
});
