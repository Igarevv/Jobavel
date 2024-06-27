<x-header.drop>
    <div class="col-sm-8 col-md-7 py-4">
        <h4>Welcome, <span class="fw-bold fst-italic">{{ session('user.name', 'user') }}</span></h4>
        <p class="text-body-secondary">Add some information about the album below, the author, or any other
            background context. Make it a few sentences long so folks can pick up some informative tidbits.
            Then, link them off to some social networking sites or contact information.</p>
    </div>
    <div class="col-sm-4 offset-md-1 py-4">
        <h4>Contact</h4>
        <ul class="list-unstyled">
            <li><a href="#" class="text-white">Follow on Twitter</a></li>
            <li><a href="#" class="text-white">Like on Facebook</a></li>
            <li><a href="#" class="text-white">Email me</a></li>
        </ul>
    </div>
</x-header.drop>
