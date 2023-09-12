<div class="terminate-popup-overlay" id="terminatePopup">
    <div class="terminate-popup">
        <h3>Attention Required</h3>
        <hr>
        <p>Are you sure you want to terminate this user?</p>
        <p>Terminating a user will remove all their data from the database.</p>
        <p>This action cannot be undone.</p>
        <br>
        <p>User: <span class="PLACEHOLDER-USER"></span> (ID: <span class="PLACEHOLDER-ID"></span>)</p>
        <hr>
        <div class="terminate-popup-buttons">
            <button class="button-success" onclick="terminate(this)">Accept</button>
            <button class="button-danger" onclick="cancel()">Deny</button>
        </div>
    </div>
</div>