<form wire:submit="saveData()">
    <div class="row" id="contact">
        <div class="col-lg-4 form-group">
            <label>National ID</label>
            <input name="nid" wire:model.live="nid"  
                class="form-control" 
                type="text" 
                placeholder="YOUR NID NUMBER...*" 
                required>
            @error('nid')
                <span class="text-danger" role="alert">{{ $message }}</span>            
            @enderror
        </div>
        <div class="col-lg-4 form-group">
            <label>Phone Number</label>
            <input wire:model.live="phone" 
                class="form-control" 
                type="tel" 
                placeholder="YOUR PHONE..." 
                required>
            @error('phone')
                <span class="text-danger" role="alert">{{ $message }}</span>            
            @enderror
        </div>
        <div class="col-lg-4 form-group">
            <label>Email Address</label>
            <input wire:model.live="email" 
                class="form-control" 
                type="email" 
                placeholder="EMAIL ADDRESS...*" 
                required>
            @error('email')
                <span class="text-danger" role="alert">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-lg-6 mt-3 form-group">
            <label>Password</label>
            <input wire:model.live="password"
                class="form-control" 
                type="password" 
                required>
            @error('password')
                <span class="text-danger" role="alert">{{ $message }}</span>            
            @enderror
        </div>
        <div class="col-lg-6 mt-3 form-group">
            <label>Confirm Password</label>
            <input wire:model.live="password_confirmation" 
                class="form-control" 
                type="password" 
                required>
        </div>
        <div class="col-lg-12 mt-2">
            <button type="submit" class="btn btn-md btn-warning" id="form-submit">SEND MESSAGE NOW
                <div wire:loading="saving">Processing</div>
            </button>
        </div>
    </div>
</form>