export default class PerfilService {
    constructor(resource) {
        this._resource = resource('api/perfis/listing');
    }

    lista() {
        return this._resource
            .query()
            .then(res => res.json(), err => {
                console.log(err)
                throw new Error('Nao foi possível obter os perfis. Tente mais tarde')
            })
    }
}