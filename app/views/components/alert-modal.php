<?php
// Usage: include this file in your layout or page where you want the modal to appear
// It will show if $_SESSION['success'] or $_SESSION['error'] is set
$type = isset($_SESSION['success']) ? 'success' : (isset($_SESSION['error']) ? 'error' : '');
$message = $_SESSION['success'] ?? $_SESSION['error'] ?? '';
if ($type && $message):
    $headingClass = $type === 'success' ? 'text-green-600' : 'text-red-600';
    $buttonClass = $type === 'success' ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700';
    $icon = $type === 'success'
        ? '<svg class="w-12 h-12 mx-auto mb-2 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="#D1FAE5"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2l4-4" /></svg>'
        : '<svg class="w-12 h-12 mx-auto mb-2 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="#FEE2E2"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 9l-6 6m0-6l6 6" /></svg>';
?>
<div id="alertModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
    <div class="relative w-full max-w-md p-6 text-center bg-white rounded-lg shadow-lg animate-fade-in">
        <button onclick="closeAlertModal()" class="absolute text-2xl font-bold text-gray-400 top-2 right-2 hover:text-gray-700">&times;</button>
        <?php echo $icon; ?>
        <div class="mb-4">
            <h3 class="text-2xl font-bold mb-2 <?php echo $headingClass; ?>">
                <?php echo $type === 'success' ? 'Success!' : 'Error!'; ?>
            </h3>
            <p class="text-base text-gray-700">
                <?php echo htmlspecialchars($message); ?>
            </p>
        </div>
        <button onclick="closeAlertModal()" class="w-full py-2 mt-2 rounded <?php echo $buttonClass; ?> text-white font-semibold text-lg transition">
            OK
        </button>
    </div>
</div>
<script>
function closeAlertModal() {
    document.getElementById('alertModal').style.display = 'none';
}
// Auto-dismiss after 3 seconds
setTimeout(closeAlertModal, 3000);
</script>
<style>
@keyframes fade-in {
  from { opacity: 0; transform: scale(0.95); }
  to { opacity: 1; transform: scale(1); }
}
.animate-fade-in { animation: fade-in 0.2s ease; }
</style>
<?php unset($_SESSION['success'], $_SESSION['error']); endif; ?>
