package com.app.kostpink.activity;


import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.database.Cursor;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.net.Uri;
import android.os.Bundle;
import android.provider.MediaStore;
import android.util.Log;
import android.view.KeyEvent;
import android.view.View;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.Toast;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import com.app.kostpink.Config;
import com.app.kostpink.MainActivity;
import com.app.kostpink.R;
import com.app.kostpink.Rest.ApiClient;
import com.app.kostpink.SharedPrefManager;
import com.app.kostpink.model.UpdateAvatarResponse;
import com.bumptech.glide.Glide;
import com.bumptech.glide.request.RequestOptions;

import java.io.ByteArrayOutputStream;
import java.io.File;

import okhttp3.MediaType;
import okhttp3.MultipartBody;
import okhttp3.RequestBody;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class UpdateAvatar extends AppCompatActivity {
    Button btn_update_avatar;
    ImageView img_avatar;
    LinearLayout btn_takepicture;
    SharedPrefManager sharedPrefManager;
    String id_customer, name, email, avatar, phone, username, picturePath;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_update_avatar);


        //hide actionbar
        getSupportActionBar().hide();


        sharedPrefManager = new SharedPrefManager(this);
        name = sharedPrefManager.getCustomer().getNama_customer();
        email = sharedPrefManager.getCustomer().getEmail();
        username = sharedPrefManager.getCustomer().getUsername();
        phone = sharedPrefManager.getCustomer().getTelepon();
        id_customer = sharedPrefManager.getCustomer().getId_customer();
        avatar = sharedPrefManager.getCustomer().getAvatar();

        img_avatar = findViewById(R.id.img_avatar);
        Glide.with(this).load(Config.IMAGE_URL + avatar)
                .apply(new RequestOptions()).into(img_avatar);

        btn_takepicture = findViewById(R.id.btn_take);
        btn_takepicture.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                selectImage(UpdateAvatar.this);
            }
        });
        btn_update_avatar = (Button) findViewById(R.id.btn_updateavatar);
        btn_update_avatar.setVisibility(View.GONE);
        btn_update_avatar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Confirm();
            }
        });

    }

    private void selectImage(Context context) {
        final CharSequence[] options = {"Take Photo", "Choose from Gallery", "Cancel"};

        AlertDialog.Builder builder = new AlertDialog.Builder(context);
        builder.setTitle("Choose your profile picture");

        builder.setItems(options, new DialogInterface.OnClickListener() {

            @Override
            public void onClick(DialogInterface dialog, int item) {

                if (options[item].equals("Take Photo")) {
                    Intent takePicture = new Intent(MediaStore.ACTION_IMAGE_CAPTURE);
                    startActivityForResult(takePicture, 0);

                } else if (options[item].equals("Choose from Gallery")) {
                    Intent pickPhoto = new Intent(Intent.ACTION_PICK, MediaStore.Images.Media.EXTERNAL_CONTENT_URI);
                    startActivityForResult(pickPhoto, 1);

                } else if (options[item].equals("Cancel")) {
                    dialog.dismiss();
                }
            }
        });
        builder.show();
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        if (resultCode != RESULT_CANCELED) {
            switch (requestCode) {
                case 0:
                    if (resultCode == RESULT_OK && data != null) {
                        Bitmap selectedImage = (Bitmap) data.getExtras().get("data");
                        img_avatar.setImageBitmap(selectedImage);
                        Uri tempUri = getImageUri(getApplicationContext(), selectedImage);
                        picturePath = getRealPathFromURI(tempUri);
                        btn_update_avatar.setVisibility(View.VISIBLE);
                    }

                    break;
                case 1:
                    if (resultCode == RESULT_OK && data != null) {
                        Uri selectedImage = data.getData();
                        String[] filePathColumn = {MediaStore.Images.Media.DATA};
                        if (selectedImage != null) {
                            Cursor cursor = getContentResolver().query(selectedImage,
                                    filePathColumn, null, null, null);
                            if (cursor != null) {
                                cursor.moveToFirst();

                                int columnIndex = cursor.getColumnIndex(filePathColumn[0]);
                                picturePath = cursor.getString(columnIndex);
                                img_avatar.setImageBitmap(BitmapFactory.decodeFile(picturePath));
                                btn_update_avatar.setVisibility(View.VISIBLE);
                                cursor.close();
                            }
                        }

                    }
                    break;
            }
        }
    }

    public Uri getImageUri(Context inContext, Bitmap inImage) {
        ByteArrayOutputStream bytes = new ByteArrayOutputStream();
        inImage.compress(Bitmap.CompressFormat.JPEG, 100, bytes);
        String path = MediaStore.Images.Media.insertImage(inContext.getContentResolver(), inImage, "Title", null);
        return Uri.parse(path);
    }

    public String getRealPathFromURI(Uri uri) {
        String path = "";
        if (getContentResolver() != null) {
            Cursor cursor = getContentResolver().query(uri, null, null, null, null);
            if (cursor != null) {
                cursor.moveToFirst();
                int idx = cursor.getColumnIndex(MediaStore.Images.ImageColumns.DATA);
                path = cursor.getString(idx);
                cursor.close();
            }
        }
        return path;
    }

    private void Confirm() {
        File imageFile = new File(picturePath);
        RequestBody reqBody = RequestBody.create(MediaType.parse("multipart/form-file"), imageFile);
        MultipartBody.Part partImage = MultipartBody.Part.createFormData("avatar", imageFile.getName(), reqBody);
        Log.d("Confirm", "Confirm: " + partImage);

        Call<UpdateAvatarResponse> call = ApiClient
                .getInstance()
                .getApi()
                .updateAvatar(partImage, RequestBody.create(MediaType.parse("text/plain"), id_customer));

        call.enqueue(new Callback<UpdateAvatarResponse>() {
            @Override
            public void onResponse(Call<UpdateAvatarResponse> call, Response<UpdateAvatarResponse> response) {

                UpdateAvatarResponse updateAvatarResponse = response.body();
                if (updateAvatarResponse.getStatus().equals("true")) {
                    sharedPrefManager.saveCustomer(updateAvatarResponse.getCustomer());

                    Intent intent = new Intent(UpdateAvatar.this, MainActivity.class);
                    intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
                    startActivity(intent);
                    finish();

                } else {
                    Toast.makeText(UpdateAvatar.this, updateAvatarResponse.getMessage(), Toast.LENGTH_SHORT).show();
                }

            }

            @Override
            public void onFailure(Call<UpdateAvatarResponse> call, Throwable t) {
                Toast.makeText(UpdateAvatar.this, t.getMessage(), Toast.LENGTH_SHORT).show();
            }
        });
    }

    public boolean onKeyDown(int keyCode, KeyEvent event) {
        if (keyCode == KeyEvent.KEYCODE_BACK) {
            Intent i = new Intent(UpdateAvatar.this, ProfileActivity.class);
            finish();
            return true;
        }
        return super.onKeyDown(keyCode, event);
    }
}