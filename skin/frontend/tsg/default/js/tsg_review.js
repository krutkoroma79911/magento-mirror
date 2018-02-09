class recentlyViewed {

    getProductsToLocalStorage(getProductsUrl) {
        new Ajax.Request(getProductsUrl, {
            method: 'Post',
            requestHeaders: {Accept: 'application/json'},
            parameters: {
                'ajax': true
            },
            onSuccess: this.createBlockAfterAjaxRequest.bind(this)

        })
    }

    createBlockAfterAjaxRequest(response){
    if (response.responseJSON !== null) {
        var result = response.responseText;
        var createdTime = new Date().getTime();
        localStorage.setItem('productObject', ('{"products":' + result + ', "ttl": ' + createdTime + '}'));
        this.renderViewBlock().bind(this);
    }}

    renderViewBlock() {
        var div =
            '<div class="block-title">' +
            '<strong><span>Recently Viewed Products</span></strong>' +
            '</div>' +
            '<div class="block-content">' +
            '<ol id="recently-viewed-items" class="mini-products-list">';
        var localProducts = this.getProductsStorage();
        var products = localProducts['products'];
        var productTemplate = new Template(
            '<li class="item">' +
            '<a href= #{url}>' +
            '<span class="product-image"><img src=#{img} width="50"width="50"  alt=#{name}></span>' +
            '</a>' +
            '<div class="product-details">' +
            '<p class="product-name">  ' +
            '<a href=#{url}>#{name}' +
            '</a>' +
            '</p>' +
            '</div>' +
            '</li>'
        );
        products.forEach(function (product, i, products) {
            div += productTemplate.evaluate(product);
        });
        div += '<script type="text/javascript">decorateList(\'recently-viewed-items\');<\/script></ol></div>';
        var insert = document.createElement('div');
        insert.setAttribute('class', 'block block-list block-viewed');
        insert.innerHTML = div;
        debugger;
        var block = document.getElementsByClassName('col-right sidebar');
        block[0].insertBefore(insert, block[0].firstChild);
    }


    deleteLogginCookie(deleteCookieUrl) {
        new Ajax.Request(deleteCookieUrl, {
            method: 'Post',
            requestHeaders: {Accept: 'application/json'},
            parameters: {
                'cookie': 'loggin'
            }
        })
    }


    productExists(id, products) {
        return products.some(function (product) {
            return product.id === id;
        });
    }

    getProductsStorage() {
        return JSON.parse(localStorage.getItem('productObject'));
    }

    setProductsToStorage(products) {
        localStorage.setItem('productObject', JSON.stringify(products));
    }
}