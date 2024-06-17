class WordPressRestClient {
    /**
     * @template T
     * @param {string} endpoint 
     * @param {any} data
     * @returns {Promise<T|null>}
     */
    async post(endpoint, data) {
        try {
            let response = await fetch(`/wp-json/${endpoint}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(data),
            });

            return response.json();
        } catch (error) {
            return null;
        }
    }

    /**
     * @template T
     * @param {string} endpoint 
     * @param {Record<string, string>|undefined} params = undefined
     * @returns {Promise<T|null>}
     */
    async get(endpoint, params = undefined) {
        try {
            let urlSearchParams = new URLSearchParams(params);
            let response = await fetch(`/wp-json/${endpoint}?${urlSearchParams}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
            });
            let data = response.json();
            console.log(data);

            return data;
        } catch (error) {
            return null;
        }
    }

    /**
     * @template T
     * @param {string} endpoint 
     * @returns {Promise<T|null>}
     */
    async delete(endpoint) {
        try {
            let response = await fetch(`/wp-json/${endpoint}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
            });

            return response.json();
        } catch (error) {
            return null;
        }
    }
};
