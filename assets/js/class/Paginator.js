import Validation from './Validation';

export default class Paginator {

    constructor(
        url,
        page = null,
        limit = null,
    ) {
        this.url = url;
        this.page = page || 1;
        this.limit = limit || 50;
        this.filters = {};
        this.resources = [];
        this.limits = [10, 25, 50, 100];

        this.pageFrom = 1;
        this.pageTo = 1;
        this.itemFrom = 0;
        this.itemTo = limit;
        this.hasPrevious = false;
        this.hasNext = false;

        this.isLoading = false;

        this.new = {};
        this.newValidation = null;
    }

    load(filters = {}) {
        const q = Object.assign({}, filters, this.filters);
        q.page = this.page;
        q.limit = this.limit;

        const r = new Request(this.url + '?' + new URLSearchParams(q).toString(), {
            method: 'GET',
            headers: new Headers({
                'Accept': 'application/json',
                'Content-Type': 'application/json;charset=UTF-8',
            }),
        });

        this.isLoading = true;

        return fetch(r)
            .then(response => {
                this.page = parseInt(response.headers.get('x-paginator-page'), 10);
                this.limit = parseInt(response.headers.get('x-paginator-limit'), 10);
                this.count = parseInt(response.headers.get('x-paginator-count'), 10);

                this.pageFrom = this.page;
                this.pageTo = Math.ceil(this.count / this.limit);
                this.itemFrom = (this.pageFrom - 1) * this.limit;
                this.itemTo = this.itemFrom + this.limit;
                this.hasPrevious = this.page > 1;
                this.hasNext = this.page * this.limit < this.count;

                return response.json();
            })
            .then(resources => {
                this.resources = resources;
            })
            .finally(() => {
                this.isLoading = false;
            });
    }

    setLimit(limit) {
        this.limit = limit;

        return this.load();
    }

    previous() {
        this.page--;

        return this.load();
    }

    next() {
        this.page++;

        return this.load();
    }

    create() {
        const r = new Request(this.url, {
            method: 'POST',
            headers: new Headers({
                'Content-Type': 'application/json;charset=UTF-8',
            }),
            body: JSON.stringify(this.new),
        });

        this.newValidation = null;

        fetch(r)
            .then(response => {
                if (response.ok) {
                    this.new = {};
                    this.load();
                } else {
                    response.json().then(error => {
                        this.newValidation = new Validation(error);
                    });
                }
            });
    }

    remove(item) {
        const r = new Request(this.url.replace('.json', `/${item.id}.json`), {
            method: 'DELETE',
            headers: new Headers({
                'Content-Type': 'application/json;charset=UTF-8',
            }),
        });

        fetch(r)
            .then(() => this.load());
    }

}
