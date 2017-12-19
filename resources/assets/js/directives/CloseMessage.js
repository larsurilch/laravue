export default {
    inserted(el, binding) {
        $(el)
            .on('click', function() {
                $(this)
                    .closest('.message')
                    .transition('fade')
            })
    }
}