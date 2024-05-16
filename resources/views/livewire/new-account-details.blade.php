<form wire:submit="saveData()">
    <div class="row" id="contact">
        <div class="col-lg-4 mb-3 form-group">
            <label>Full Names</label>
            <input name="names" wire:model.live="names"  
                class="form-control" 
                type="text" 
                placeholder="Your Full Names...*" 
                required>
            @error('names')
                <span class="text-danger" role="alert">{{ $message }}</span>            
            @enderror
        </div>
        <div class="col-lg-2 mb-3 form-group">
            <label>Province</label>
            <select name="province" wire:model.live='province' id="" class="form-control">
                <option value="">-- Select Province -- </option>
                <option value="Kigali">Kigali City</option>
                <option value="Eastern">Eastern Province</option>
                <option value="Northern">Northern Province</option>
                <option value="Western">Western Province</option>
                <option value="Southern">Southern Province</option>
            </select>
            @error('province')
                <span class="text-danger" role="alert">{{ $message }}</span>            
            @enderror
        </div>
        <div class="col-lg-2 mb-3 form-group">
            <label>District</label>
            <input wire:model.live="district" 
                class="form-control" 
                type="text" 
                placeholder="District...*" 
                required>
            @error('district')
                <span class="text-danger" role="alert">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-lg-2 mb-3 form-group">
            <label>Sector</label>
            <input wire:model.live="sector" 
                class="form-control" 
                type="text" 
                placeholder="Sector...*" 
                required>
            @error('sector')
                <span class="text-danger" role="alert">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-lg-2 mb-3 form-group">
            <label>Cell</label>
            <input wire:model.live="cell" 
                class="form-control" 
                type="text" 
                placeholder="Cell...*" 
                required>
            @error('cell')
                <span class="text-danger" role="alert">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-lg-3 form-group">
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
        <div class="col-lg-3 form-group">
            <label>Date of Birth</label>
            <input wire:model.live="date_of_birth" 
                class="form-control" 
                type="date" 
                value="2000-01-01"
                min="1980-01-01" 
                max="2009-12-31" 
                required>
            @error('date_of_birth')
                <span class="text-danger" role="alert">{{ $message }}</span>            
            @enderror
        </div>
        <div class="col-lg-3 form-group">
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
        <div class="col-lg-3 form-group">
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