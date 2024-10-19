<div class="box"
    style="
    padding:80px 80px;
    font-family: 'ubuntu';
    margin:auto;
    height: 300px;
    width: 400px;
    display: flex;
    align-items: center; 
    justify-content: center; 
    background-color: rgba(142, 255, 255, 0.411);
    border-radius:10px;
    border:solid blue 4px;">
    <button
        style="
        height: 40px;
        width: 100px;
        background-color:#000d7e; 
        color:white;
        border: none; border-radius: 5px;">
        <a style="font-size: 12px;
        text-decoration:
        none; color:
        white;"
            href="{!! route('resetPswd', $token) !!}">Reset Password</a>
    </button>
</div>
