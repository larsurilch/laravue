export default class MarcaService {
    constructor(resource) {
        this._resource = resource('api/marcas/listing');
    }

    lista() {
        return this._resource
            .query()
            .then(res => res.json(), err => {
                console.log(err)
                throw new Error('Nao foi possível obter as marcas. Tente mais tarde')
            })
    }
}