export default class EstadoService {
    constructor(resource) {
        this._resource = resource('api/estados/listing');
    }

    lista() {
        return this._resource
            .query()
            .then(res => res.json(), err => {
                console.log(err)
                throw new Error('Nao foi possível obter os Estados. Tente mais tarde')
            })
    }
}