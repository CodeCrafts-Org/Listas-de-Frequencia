/**
 * @param {Event} event 
 * @return {Promise<void>}
 */
async function handleListingLoad(event) {
    const container = document.querySelector('.listas-de-frequencia__listing');
    if (container === null) {
        return;
    }
    await handleListingFetch(1);
}

/**
 * @param {number} page
 * @return {Promise<void>}
 */
async function handleListingFetch(page) {
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
    const paginated = await wordPressRestClient.get(endpoint, params);
    if (paginated === null) {
        renderListingError(listingItems);
    } else if (paginated.items.length === 0) {
        renderListingEmpty(listingItems);
    } else {
        renderListingItems(listingItems, paginated.items);
        renderListingPaginator(listingPagination, paginated.totalPages, page);
    }
    return;
}

/**
 * @param {Element} body 
 * @return {void}
 */
function renderListingError(body) {
    const errorTemplate = document.getElementById('listing--error');
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
function renderListingEmpty(body) {
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
function renderListingItems(body, items) {
    const itemTemplate = document.getElementById('listing--item');
    if (itemTemplate === null) {
        return;
    }
    items.forEach(function (item) {
        let itemElement = itemTemplate.content.cloneNode(true);
        let itemId = itemElement.querySelector('.item__id--body');
        if (itemId !== null) {
            itemId.innerHTML = item.id;
        }
        let itemTitulo = itemElement.querySelector('.item__titulo--body');
        if (itemTitulo !== null) {
            itemTitulo.innerHTML = item.titulo;
        }
        let itemData = itemElement.querySelector('.item__data--body');
        if (itemData !== null) {
            itemData.innerHTML = item.data.formatted;
        }
        let deleteItem = itemElement.querySelector('.item--delete');
        if (deleteItem !== null) {
            deleteItem.addEventListener('click', async function (event) {
                deleteItem.disabled = true;
                const wordPressRestClient = new WordPressRestClient();
                const endpoint = `codecrafts/listas-de-frequencia/v1/listas/${item.id}`;
                let deleted = await wordPressRestClient.delete(endpoint);
                if (deleted === false) {
                    return;
                }
                const row = event.target.closest('tr');
                if (row !== null) {
                    await handleListingFetch(1);
                }
                deleteItem.disabled = false;
            });
        }
        let detailItem = itemElement.querySelector('.item--details');
        if (detailItem !== null) {
            detailItem.href = `?page=listas-de-frequencia&id=${item.id}`;
        }
        body.appendChild(itemElement);
    });
}

/**
 * @param {Element} container 
 * @param {number} totalPages 
 * @param {number} currentPage
 * @return {void}
 */
function renderListingPaginator(container, totalPages, currentPage) {
    if (totalPages <= 1) {
        return;
    }
    const visiblePageCount = 5;
    let startPage = Math.max(1, currentPage - Math.floor(visiblePageCount / 2));
    const endPage = Math.min(totalPages, currentPage + Math.floor(visiblePageCount / 2));

    if (startPage > 1) {
        const firstButton = document.createElement('button');
        firstButton.textContent = 'Primeira página';
        firstButton.addEventListener('click', () => handleListingFetch(1));
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
        pageButton.addEventListener('click', () => handleListingFetch(page));
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
        lastButton.addEventListener('click', () => handleListingFetch(totalPages));
        container.appendChild(lastButton);
    }
}

window.addEventListener('load', handleListingLoad);
