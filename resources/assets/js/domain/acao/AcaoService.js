export default class AcaoService {
    constructor(resource) {
        this._resource = resource('api/acoes/listing');
    }

    lista() {
        return this._resource
            .query()
            .then(res => res.json(), err => {
                console.log(err)
                throw new Error('Nao foi possível obter as ações. Tente mais tarde')
            })
    }
}