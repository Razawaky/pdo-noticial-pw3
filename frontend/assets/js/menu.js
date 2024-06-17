$(document).ready(function(){
    //ver todos os clicks em links
    $('.links').click(function(e){
        e.preventDefault()
        let url = $(this).attr('href')
        $('#content').empty()
        $('#content').load(url)
    })
})