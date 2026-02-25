$(document).on('click','#hide_this_con',function(){
    var container = document.querySelector('.hide_this_container');
    container.classList.add('active');
});
$(document).on('click','#show_this_con',function(){
    var container = document.querySelector('.hide_this_container');
    container.classList.remove('active');
});

function show_con(id){
    var container = document.querySelector('.hide_this_container#'+"_get"+id);
    console.log(container)
    container.classList.remove('active');
}
function hide_con(id){
    var container = document.querySelector('.hide_this_container#'+"_get"+id);
    container.classList.add('active');
}
    