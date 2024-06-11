$(document).ready(()=>{
    let objProductos= JSON.parse(productos);

    let aleatorios="";

    for(let i=0; i<=2; i++){
        let indice_aleatorio=Math.floor(Math.random() * 100) + 1;
        let objeto=objProductos[indice_aleatorio];
        if(i == 0) aleatorios+= `<div class="row">`;
        aleatorios+= `
        <div class="col-sm-12 col-md-6 col-lg-4">
            <div class="card">
                <div id="carousel-${objeto.id}" class="carousel slide">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="${objeto.images[0]}" class="d-block w-100 img-fluid" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="${objeto.images[1]}" class="d-block w-100 img-fluid" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="${objeto.images[2]}" class="d-block w-100 img-fluid" alt="...">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel-${objeto.id}" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carousel-${objeto.id}" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                    </button>
                </div>


                <div class="card-body">
                    <h5 class="card-title text-center">${objeto.title}</h5>
                    <h6 class="card-subtitle mb-2 text-body-secondary text-center" style="color: blue;">Rating: ${objeto.rating}</h6>
                    
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-secondary btnCarrito btn-lg" data-id="${objeto.id}">$${objeto.price}</button>
                    </div>
                    
                </div>
            </div>
        </div>
        `;
        if(i == 2) aleatorios+= `</div> <!-- /row -->`;
    }


    $("div#verProductos").html(aleatorios);
    $("button.btnCarrito").click(function(){
        console.log($(this).attr("data-id"));
    });

});