function setSearch(inputId, apiUrl, tableBodyId) {
    let timeout = null;
    const input = document.getElementById(inputId);
    if (!input) return;

    input.addEventListener('keyup', function () {
        clearTimeout(timeout);
        const query = this.value;

        timeout = setTimeout(() => {
            fetch(`${apiUrl}?name=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    let rows = '';
                    if (data.length === 0) {
                        rows = `<tr><td colspan="8" style="text-align:center;">No result found</td></tr>`;
                    } else {
                        data.forEach(item => {
                            rows += renderRow(item);
                        });
                    }
                    const tbody = document.getElementById(tableBodyId);
                    if (tbody) tbody.innerHTML = rows;
                });
        }, 300); // debounce 300ms
    });
}
