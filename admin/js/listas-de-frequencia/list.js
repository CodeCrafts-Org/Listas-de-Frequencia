/**
 * @param {Event} event 
 * @return {Promise<void>}
 */
async function handleLoad(event) {
    const container = document.querySelector('.listas-de-frequencia__listing');
    if (container === null) {
        return;
    }
    await handleFetch(1);
}

/**
 * @param {number} page
 * @return {Promise<void>}
 */
async function handleFetch(page) {
    const listingItems = document.querySelector('.listing__items');
    if (listingItems === null) {
        return;
    }
    const listingPagination = document.querySelector('.listing__pagination');
    if (listingPagination === null) {
        return;
    }
    listingItems.replaceChildren();
    listingPagination.replaceChildren();
    const wordPressRestClient = new WordPressRestClient();
    const endpoint = 'codecrafts/listas-de-frequencia/v1/listas';
    const params = {
        page: page
    };
    const paginated = wordPressRestClient.get(endpoint, params);
    if (paginated === null) {
        renderError(listingItems);
    } else if (paginated.items.length === 0) {
        renderEmpty(listingItems);
    } else {
        renderItems(listingItems, paginated.items);
        renderPaginator(listingPagination, paginated.totalPages, page);
    }
    return;
}

/**
 * @param {Element} body 
 * @return {void}
 */
function renderError(body) {
    const errorTemplate = document.getElementById('listing--item');
    if (errorTemplate === null) {
        return;
    }
    const errorElement = errorTemplate.content.cloneNode(true);
    body.appendChild(errorElement);
}

/**
 * @param {Element} body 
 * @return {void}
 */
function renderEmpty(body) {
    const emptyTemplate = document.getElementById('listing--empty');
    if (emptyTemplate === null) {
        return;
    }
    const emptyElement = emptyTemplate.content.cloneNode(true);
    body.appendChild(emptyElement);
}

/**
 * @param {Element} body 
 * @param {Array<any>} items
 * @return {void}
 */
function renderItems(body, items) {
    const itemTemplate = document.getElementById('listing--item');
    if (itemTemplate === null) {
        return;
    }
    items.forEach(function (item) {
        let itemElement = itemTemplate.content.cloneNode(true);
        itemElement.querySelector('.item__id--body')?.innerHTML = item.id;
        itemElement.querySelector('.item__titulo--body')?.innerHTML = item.titulo;
        itemElement.querySelector('.item__data--body')?.innerHTML = item.data;
        itemElement.querySelector('.item--delete')?.addEventListener('click', async function (event) {
            const wordPressRestClient = new WordPressRestClient();
            const endpoint = `codecrafts/listas-de-frequencia/v1/listas/${item.id}`;
            let deleted = await wordPressRestClient.delete(endpoint);
            if (deleted === false) {
                return;
            }
            event.target.closest('tr').delete();
        });
        itemElement.querySelector('.item--details')?.addEventListener('click', async function (event) {
            //
        });
        body.appendChild(itemElement);
    });
}

/**
 * @param {Element} container 
 * @param {number} totalPages 
 * @param {number} currentPage
 * @return {void}
 */
function renderPaginator(container, totalPages, currentPage) {
    if (totalPages <= 1) {
        return;
    }
    const visiblePageCount = 5;
    let startPage = Math.max(1, currentPage - Math.floor(visiblePageCount / 2));
    const endPage = Math.min(totalPages, currentPage + Math.floor(visiblePageCount / 2));

    if (startPage > 1) {
        const firstButton = document.createElement('button');
        firstButton.textContent = 'Primeira página';
        firstButton.addEventListener('click', () => handleFetch(1));
        container.appendChild(firstButton);
        startPage++;
    }
    if (startPage > 2) {
        const gapButton = document.createElement('button');
        gapButton.textContent = '...';
        gapButton.disabled = true;
        container.appendChild(gapButton);
    }
    for (let page = startPage; page <= endPage; page++) {
        const pageButton = document.createElement('button');
        pageButton.textContent = page;
        pageButton.classList.toggle('active', page === currentPage);
        pageButton.addEventListener('click', () => handleFetch(page));
        container.appendChild(pageButton);
    }
    if (endPage < totalPages - 1) {
        const gapButton = document.createElement('button');
        gapButton.textContent = '...';
        gapButton.disabled = true;
        container.appendChild(gapButton);
    }
    if (endPage < totalPages) {
        const lastButton = document.createElement('button');
        lastButton.textContent = 'Última página';
        lastButton.addEventListener('click', () => handleFetch(totalPages));
        container.appendChild(lastButton);
    }
}

window.addEventListener('load', handleLoad);
