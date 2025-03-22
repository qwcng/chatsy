
    
        
function notification(title){
    const result = document.getElementById("result");
    
    result.innerHTML = ` 
                        <div class='notification' onclick='hide_notify()'>
                            <div class='notify-sign'><i class='positive fa-solid fa-check fa-2xl'></i></div>
                            <div class='notification-header'>${title}</div>
                        </div>`
    ;
    const x = document.querySelector(".notification");
    setTimeout(() => {
    x.style.width ='300px';
    x.style.opacity = '1';
    },10);
        // setTimeout(3);
    setTimeout(() => {
    x.style.width ='0px';
    x.style.opacity = '0';
    }, 3000);
   
}
function hide_notify(){
    var x = document.querySelector('.notification');
    if(x){
    x.style.width ='0px';
    x.style.opacity = '0';
}
}
