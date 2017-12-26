export default class GlobalService {
    constructor(router) {
        this._router = router;
    }

    storage(message, status, url) {
        localStorage.setItem('message', message)
        localStorage.setItem('status', status)
        this._router.push(url)
    }
}