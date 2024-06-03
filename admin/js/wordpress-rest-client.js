class WordPressRestClient {
    async post(endpoint, data) {
        try {
            let response = await fetch(`/wp-json/${endpoint}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            });

            return response.json();
        } catch (error) {
            return null;
        }
    }
};
