export const fetchAction = async (actionData) => {
    return fetch('/actions.php', {
        method: "POST",
        headers: {
            'Accept': 'application/json',
            "Content-Type": "application/json"
        },
        body: JSON.stringify(actionData)
    })
    .then(response => response.json())
    .then(data => {
        return data
    });
}