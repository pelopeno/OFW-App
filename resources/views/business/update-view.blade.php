<div class="update-view-main" style="display: none;">
    <a href="#" class="update-view-x-btn"><img src="/assets/x-btn.png"/></a>
    <div class="update-view-card">
        <h2 id="updateViewBusinessName">Business Name</h2>
        <p class="update-view-date" id="updateViewDate">Posted 2 days ago</p>
        <img src="/assets/cafe-img-sample.png" class="update-view-image" id="updateViewImage" />
        <hr class="dotted-hr" />
        <p class="update-view-content" id="updateViewContent">Update content goes here...</p>
        
        <button class="delete-update-view-btn" id="deleteUpdateFromView" style="display: none;">Delete Update</button>
    </div>
</div>

<style>
    .update-view-main {
        width: 100%;
        height: 100%;
        position: absolute;
        background-color: rgba(0, 0, 0, 0.50);
        z-index: 5;
        display: flex;
        justify-content: center;
        overflow-y: scroll;
    }

    .update-view-x-btn {
        width: 50px;
        height: 50px;
        position: absolute;
        top: 8%;
        right: 27%;
        z-index: 6;
        transition: transform 0.2s ease;
    }

    .update-view-x-btn:hover {
        transform: scale(1.1) rotate(90deg);
    }

    .update-view-x-btn img {
        width: 100%;
        height: 100%;
    }

    .update-view-card {
        width: 45%;
        min-height: fit-content;
        background-color: white;
        border: 3px solid black;
        border-radius: 25px;
        padding: 40px;
        margin-top: 5%;
        margin-bottom: 5%;
        position: relative;
        box-sizing: border-box;
    }

    .update-view-card h2 {
        font-family: "Tilt Warp", sans-serif;
        font-size: 48px;
        font-weight: 200;
        letter-spacing: -2px;
        color: #282828;
        margin: 0 0 10px 0;
    }

    .update-view-date {
        font-family: "Varela Round", sans-serif;
        font-size: 20px;
        letter-spacing: -1px;
        color: #848484;
        margin: 0 0 20px 0;
    }

    .update-view-image {
        width: 100%;
        border: 3px solid black;
        border-radius: 15px;
        margin-bottom: 10px;
    }

    .update-view-content {
        font-family: "Varela Round", sans-serif;
        font-size: 18px;
        line-height: 1.6;
        letter-spacing: -0.5px;
        color: #282828;
        margin: 20px 0;
        white-space: pre-wrap;
        word-wrap: break-word;
    }

    .delete-update-view-btn {
        display: block;
        width: 100%;
        padding: 15px;
        margin-top: 25px;
        background-color: #E57373;
        color: white;
        border: 2px solid #282828;
        border-radius: 12px;
        font-family: "Varela Round", sans-serif;
        font-size: 18px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .delete-update-view-btn:hover {
        background-color: #D32F2F;
        transform: translateY(-2px);
    }

    .dotted-hr {
        width: 100%;
        border: none;
        border-top: 2.5px dotted #ccc;
        color: #828282;
        background-color: transparent;
        height: 3px;
        margin: 25px 0;
    }

    @media (max-width: 1200px) {
        .update-view-card {
            width: 60%;
        }
    }

    @media (max-width: 768px) {
        .update-view-card {
            width: 85%;
            padding: 30px;
        }

        .update-view-card h2 {
            font-size: 36px;
        }

        .update-view-x-btn {
            width: 35px;
            height: 35px;
            top: 3%;
            right: 3%;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteUpdateFromViewBtn = document.getElementById('deleteUpdateFromView');
        
        if (deleteUpdateFromViewBtn) {
            deleteUpdateFromViewBtn.addEventListener('click', function() {
                const updateId = this.getAttribute('data-update-id');
                if (updateId) {
                    deleteUpdate(updateId);
                    const updateOverlay = document.querySelector('.update-view-main');
                    if (updateOverlay) updateOverlay.style.display = 'none';
                }
            });
        }
    });
</script>
