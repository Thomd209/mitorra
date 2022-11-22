$(document).ready(function() {
    heights = []
    let max_height=0; 
    $(".class").each(function () {
        if (max_height < $(this).height()) {
            max_height=$(this).height()
            heights.push(this)
        }
    })

    desc_blocks = heights.reverse()

    let parent = $('.parent')[0]

    for (let block of desc_blocks) {
        parent.appendChild(block)
    }
})