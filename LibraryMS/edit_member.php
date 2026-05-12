<?php
$page_title = 'Edit Member';
include 'header.php';

$id = $_GET['id'] ?? null;
$message = '';

if (!$id) {
    header('Location: members.php');
    exit;
}

// Handle Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_member'])) {
    $member_data = array(
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'phoneNumber' => $_POST['phone'], // FIX: match Java field name
        'membershipId' => $_POST['membership_id'],
        'isActive' => isset($_POST['is_active']) ? true : false
    );

    $result = apiCall(API_MEMBERS . '/' . $id, 'PUT', $member_data);
    
    if (isset($result['id'])) {
        $message = '<div class="alert alert-success">Member updated successfully! <a href="members.php">Back to list</a></div>';
    } else {
        $error_detail = isset($result['error']) ? $result['error'] : 'Unknown error';
        $message = '<div class="alert alert-error">Error updating member: ' . $error_detail . '</div>';
    }
}

// Get current member data
$member = apiCall(API_MEMBERS . '/' . $id);

if (isset($member['error']) || !isset($member['id'])) {
    echo "<h2>Error</h2><div class='alert alert-error'>Member not found or API error.</div>";
    include 'footer.php';
    exit;
}
?>

<h2>Edit Member</h2>
<?php echo $message; ?>

<form method="POST" style="max-width: 500px; margin-bottom: 30px;">
    <div class="form-group">
        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($member['name']); ?>" required>
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($member['email'] ?? ''); ?>">
    </div>

    <div class="form-group">
        <label for="phone">Phone</label>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($member['phoneNumber'] ?? ''); ?>">
    </div>

    <div class="form-group">
        <label for="membership_id">Membership ID</label>
        <input type="text" id="membership_id" name="membership_id" value="<?php echo htmlspecialchars($member['membershipId']); ?>" required>
    </div>

    <div class="form-group" style="display: flex; align-items: center; gap: 10px;">
        <input type="checkbox" id="is_active" name="is_active" <?php echo $member['isActive'] ? 'checked' : ''; ?> style="width: auto;">
        <label for="is_active" style="margin-bottom: 0;">Active Member</label>
    </div>

    <div style="margin-top: 20px;">
        <button type="submit" name="update_member" class="btn btn-success">Update Member</button>
        <a href="members.php" class="btn btn-secondary" style="text-decoration: none; margin-left: 10px;">Cancel</a>
    </div>
</form>

<?php include 'footer.php'; ?>
