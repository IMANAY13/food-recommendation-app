<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Recommendation</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        form { margin-bottom: 20px; }
        label { display: block; margin-bottom: 10px; }
    </style>
</head>
<body>
    <h1>Food Recommendation</h1>
    <form id="recommendationForm">
        <label>
            <input type="checkbox" name="spicy"> Spicy
        </label>
        <label>
            <input type="checkbox" name="vegan"> Vegan
        </label>
        <label>
            <input type="checkbox" name="glutenFree"> Gluten-Free
        </label>
        <button type="submit">Get Recommendation</button>
    </form>
    <div id="result"></div>

    <script>
        document.getElementById('recommendationForm').addEventListener('submit', async function (e) {
            e.preventDefault();
            const formData = new FormData(this);

            const response = await fetch('recommend.php', {
                method: 'POST',
                body: formData
            });
            const data = await response.json();

            document.getElementById('result').innerHTML = <h2>Recommended Food: ${data.recommendedFood}</h2>;
        });
    </script>
</body>
</html>