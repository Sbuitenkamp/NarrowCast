let counter = 0;
// setInterval(() => {
    $.ajax({
        type: 'POST',
        url: 'index.php',
        data: { url: '/modules/moduleTest' + counter },
        success: data => {
            console.log(data);
            document.querySelector('html').innerHTML = data;
            if (counter) counter--;
            else counter++;
        },
        error: () => {
            console.log('riB')
        }
    });
// }, 5000);