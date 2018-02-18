export default class PaisService {
    constructor(resource) {
        this._resource = resource('api/proprietarios/listing');
    }

    lista() {
        return this._resource
            .query()
            .then(res => res.json(), err => {
                console.log(err)
                throw new Error('Nao foi possível obter os proprietários. Tente mais tarde')
            })
    }
}