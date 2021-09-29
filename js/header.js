let slider_im = document.querySelectorAll('.slider_image')

slider_im.forEach((elem)=>{
    elem.addEventListener('click',()=>{
        clearActive();
        elem.classList.add('im_active')

    })
})

function clearActive(){
    slider_im.forEach((elem)=>{
        elem.classList.remove('im_active') 
    })
}