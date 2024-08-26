(function() {
    var client = algoliasearch('4NTX3BG05L', '3fd9c9692c9b93020eb092fc0234df61');
    var index = client.initIndex('products');
    var enterPressed = false;

    //initialize autocomplete on search input (ID selector must match)
    autocomplete('#aa-search-input',
        { hint: false }, {
            source: autocomplete.sources.hits(index, { hitsPerPage: 5 }),
            //value to be displayed in input control after user's suggestion selection
            displayKey: 'name',
            //hash of templates used when rendering dataset
            templates: {
                //'suggestion' templating function used to render a single suggestion
                suggestion: function (suggestion) {
                    const markup = `
                        <div class="algolia-result">
                            <span>
                                <img src="${window.location.origin}/storage/${suggestion.product_image}" alt="img" class="algolia-thumb">
                                ${suggestion._highlightResult.product_name.value}
                            </span>
                            <span>
                               Cena: ${( (Math.round(suggestion._highlightResult.product_price.value * 100) / 100).toFixed(2) )} €
                            </span>
                        </div>
                        <div class="algolia-details">
                            <span>Veľkosť: ${suggestion.product_size}</span>
                        </div>
                    `;
                    return markup;
                    /*return '<span>' +
                        suggestion._highlightResult.product_name.value + '</span></span> ' +
                        suggestion.product_price + '€</span>';*/
                },
                empty: function (result) {
                    return 'Bohužiaľ sme nenašli výsledky pre: "' + result.query + '"';
                }
            }
    }).on('autocomplete:selected', function (event, suggestion, dataset) {
        window.location.href = window.location.origin + '/produkty/' + suggestion.slug;
        enterPressed = true;
    }).on('keyup', function(event) {
        if (event.keyCode == 13 && !enterPressed) {
            window.location.href = window.location.origin + '/vyhladavanie?q=' + document.getElementById('aa-search-input').value;
        }
    });
})();
