<body>
    <h2>Upload your CSV</h2>
    <form method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="get_file" value="" />
        <input type="submit" name="submit" value="Calculate" />
    </form>
</body>
