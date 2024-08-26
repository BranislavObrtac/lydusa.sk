
    const search = instantsearch({
        appId: '4NTX3BG05L',
        apiKey: '3fd9c9692c9b93020eb092fc0234df61',
        indexName: 'products',
        urlSync: true
    });



    // initialize SearchBox
    search.addWidget(
        instantsearch.widgets.searchBox({

            container: '#search-box',
            placeholder: 'Hľadať produkt..',

        })
    );

    search.addWidget(
        instantsearch.widgets.hits({
            container: '#hits',
            hitsPerPage:10,
            templates: {
                empty: function (result) {
                    return 'Bohužiaľ sme nenašli výsledky pre: "' + result.query + '"';
                },
                item: function (item) {
                    return `
                    <div class="container">
                        <a href="${window.location.origin}/produkty/${item.slug}">
                            <div class="row">
                                <div class="text-center col-lg-4 col-xs-12 col-12">
                                    <img class="instantsearch-images" src="${window.location.origin}/storage/${item.product_image}" alt="img">
                                </div>

                                <div class="col-lg-8 col-xs-12 col-12">
                                    <div class="row">
                                        <b style="font-size: 12pt">${item._highlightResult.product_name.value}</b>
                                    </div>
                                    <div class="row">
                                        <div>
                                            ${item._highlightResult.product_details.value}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div>
                                            Cena vrátane DPH: <b>${((Math.round((item.product_price) * 100) / 100).toFixed(2))}</b> €
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <hr>
                    <div class="spacer"></div>
                    `;
                }
            }
        })
    );

    // initialize pagination
    search.addWidget(
        instantsearch.widgets.pagination({
            container: '#pagination',
            maxPages: 10,

        })
    );

    search.addWidget(
        instantsearch.widgets.stats({
            container: '#stats-container'
        })
    );

    // initialize RefinementList
    search.addWidget(
        instantsearch.widgets.refinementList({
            templates: {
                header: '<b style="font-size: 20px">Kategórie</b>'
            },
            container: '#refinement-list',
            attributeName: 'categories',
            sortBy: ['categories:asc'],

        })
    );
    search.addWidget(
        instantsearch.widgets.refinementList({
            templates: {
                header: '<b style="font-size: 20px">Pohlavie</b>'
            },
            container: '#refinement-list-pohlavie',
            attributeName: 'genders',
            sortBy: ['genders:asc']

        })
    );
    search.addWidget(
        instantsearch.widgets.refinementList({
            templates: {
                header: '<b style="font-size: 20px">Velkosť</b>'
            },
            container: '#refinement-list-velkost',
            attributeName: 'product_size',
            sortBy: ['product_size:asc']
        })
    );

    search.start();

