<script>
  document.addEventListener("DOMContentLoaded", function() {


    const prev_page_btn = $("#prev_page");
    const next_page_btn = $("#next_page");
    let table = window.table || $('#datatable')
    let info = table.page.info();

    $('#table_footer_text').html('Showing page ' + (info.page + 1) + ' of ' + (info.pages + 1));
    table.on('page.dt', function() {
      info = table.page.info();
      $('#table_footer_text').html('Showing page ' + (info.page + 1) + ' of ' + (info.pages + 1));
    });
    prev_page_btn.on('click', (e) => {
      table.page(info.page <= 0 ? info.page : info.page - 1).draw(false);
    })
    next_page_btn.on('click', (e) => {
      table.page(info.page + 1).draw(false);
    })

    let btns = []
    for (let index = 0; index < info.pages; index++) {
      console.log("hello", index);
      btn =
        `<li><button onclick="window.table.page(${index}).draw(false);" class=" pagination_buttons px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">${index + 1}</button></li>`
      btns.push(btn)
    }
    btns.join()
    prev_page_btn.parent("li").after(btns)

    table.on('length.dt', () => {
      $(".pagination_buttons").remove()

      info = table.page.info();
      console.log(info);
      $('#table_footer_text').html('Showing page ' + (info.page + 1) + ' of ' + (info.pages + 1));

      let btns = []
      for (let index = 0; index < info.pages; index++) {
        console.log("hello", index);
        btn =
          `<li><button onclick="window.table.page(${index}).draw(false);" class=" pagination_buttons px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">${index + 1}</button></li>`
        btns.push(btn)
      }
      btns.join()
      prev_page_btn.parent("li").after(btns)
    })
    const label = $("#datatable_length > label")
    label.contents().filter(function() {
      return this.nodeType == 3
    }).remove()
    label.addClass("block mb-4 font-medium text-sm text-gray-700")
    let span = `<span class="text-gray-700 dark:text-gray-400">{{ __('Show Per Page') }}</span>`
    $("#datatable_length > label > select").before(span)

  });
</script>
