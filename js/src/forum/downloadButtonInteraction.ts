import app from 'flarum/forum/app';
import {extend} from 'flarum/common/extend';
import Post from 'flarum/forum/components/Post';

/* global $ */

// Construct the download URL
function buildDownloadUrl(uuid: string | undefined, postId: string, csrfToken: string): string {
  if (!uuid) {
    console.error('UUID is undefined');
    return '';
  }
  const apiUrl = app.forum.attribute('apiUrl');
  return `${apiUrl}/gbcl/fof-qcloud/download/${encodeURIComponent(uuid)}/${encodeURIComponent(postId)}/${encodeURIComponent(csrfToken)}`;
}

// Define the type for the click event
function handleDownloadClick(this: Post, e: JQuery.ClickEvent): void {
  e.preventDefault();
  e.stopPropagation();

  if (!app.forum.attribute('fof-upload.canDownload')) {
    alert(app.translator.trans('fof-upload.forum.states.unauthorized'));
    return;
  }

  const uuid = e.currentTarget.dataset.fofQcloudUploadDownloadUuid;
  const postId = this.attrs.post.id();
  const csrfToken = app.session.csrfToken;

  const url = buildDownloadUrl(uuid, String(postId), csrfToken);

  try {
    window.open(url, '_blank');
  } catch (error) {
    console.error('Failed to open download URL:', error);
    alert('An error occurred while trying to download the file.');
  }
}

export default function () {
  extend(Post.prototype, 'oncreate', function () {
    this.$('[data-fof-qcloud-upload-download-uuid]')
      .off('click') // Use `.off` instead of `.unbind` for better practice
      .on('click', handleDownloadClick.bind(this));
  });
}
